#include "Functions.h"

void ReadDir(vector<string>& files, const char* PATH)
{
    for (const auto& entry : fs::directory_iterator(PATH))
    {
        string y{ entry.path().string() };
        files.push_back(y);
    }
}

void ReadFiles(vector<Entry>& entries, vector <string>& files)
{
    for (size_t i = 0; i < files.size(); i++)
    {
        ifstream in(files[i]);
        for (size_t j = 0; !in.eof(); j++)
        {
            string name, surname, subject;
            int grade;

            in >> name >> surname >> subject >> grade;

            Entry container(name, surname, subject, grade);
            entries.push_back(container);
        }
        in.close();
    }
}

void Print(vector <Entry>& entries)
{
    system("CLS");
    for (size_t i = 0; i < entries.size(); i++)
        cout << entries[i].GetName() << " " << entries[i].GetSurname() << " " << entries[i].GetSubject() << " " << entries[i].GetGrade() << endl;
}

void DeleteDirectoryContents(const char* PATH)
{
    for (const auto& entry : fs::directory_iterator(PATH))
        fs::remove_all(entry.path());
}

void WriteToDB(vector<Entry>& entries, const char* DIR)
{
    for (auto& entry : entries)
    {
        int student_ID = -1;
        string get_subject_id = "SELECT ID from subjects WHERE subject = '" + entry.GetSubject() + "';";
        int subject_ID = stoi(Select_stmt(get_subject_id, DIR)[0][0]);

        //If a student already exists, then we only insert the grade into the grades table
        if (Student_exists(entry, student_ID, DIR))
        {
            string insert_grade = "INSERT INTO grades (ID, studentID, subjectID, grade) VALUES ("
                "NULL, '"
                + to_string(student_ID) + "', '"
                + to_string(subject_ID) + "', '"
                + to_string(entry.GetGrade()) + "');";

            Insert_stmt(insert_grade, DIR);
        }
        //If a student doesn't exist, then insert the student and the grade
        else
        {
            string create_student = "INSERT INTO students (ID, name, surname) VALUES ("
                "NULL, '"
                + entry.GetName() + "', '"
                + entry.GetSurname() + "');";

            Insert_stmt(create_student, DIR);
            string get_id = "SELECT ID FROM students "
                "WHERE name = '" + entry.GetName() + "' "
                "AND surname = '" + entry.GetSurname() + "' ;";

            student_ID = stoi(Select_stmt(get_id, DIR)[0][0]);

            string insert_grade = "INSERT INTO grades (ID, studentID, subjectID, grade) VALUES ("
                "NULL, '"
                + to_string(student_ID) + "', '"
                + to_string(subject_ID) + "', '"
                + to_string(entry.GetGrade()) + "');";

            Insert_stmt(insert_grade, DIR);
        }
    }
}

//Checks whether a student with a given name and surname alrready exists, returns its ID
bool Student_exists(Entry entry, int& ID, const char* DIR)
{
    string select_students = "SELECT * FROM students;";
    Records students = Select_stmt(select_students, DIR);
    for (size_t j = 0; j < students.size(); j++)
    {
        if (entry.GetName() == students[j][1] && entry.GetSurname() == students[j][2])
        {
            ID = stoi(students[j][0]);
            return true;
        }
    }
    return false;
}


//SQL functions
int select_callback(void* p_data, int num_fields, char** p_fields, char** p_col_names)
{
    Records* records = static_cast<Records*>(p_data);
    try {
        records->emplace_back(p_fields, p_fields + num_fields);
    }
    catch (...) {
        // abort select on failure, don't let exception propogate thru sqlite3 call-stack
        return 1;
    }
    return 0;
}

void Insert_stmt(string stmt, const char* DIR)
{
    sqlite3* DB;
    char* errmsg;

    if (sqlite3_open(DIR, &DB) == SQLITE_OK)
    {
        int ret = sqlite3_exec(DB, stmt.c_str(), NULL, 0, &errmsg);
        if (ret != SQLITE_OK)
        {
            cerr << "Error in select statement " << stmt << "[" << errmsg << "]\n";
        }
        sqlite3_free(errmsg);
    }
    else
    {
        cout << "Failed to open db\n";
    }
    sqlite3_close(DB);
}

Records Select_stmt(string stmt, const char* DIR)
{
    sqlite3* DB;
    Records records;
    char* errmsg;
    int exit = sqlite3_open(DIR, &DB);
    int ret = sqlite3_exec(DB, stmt.c_str(), select_callback, &records, &errmsg);
    if (ret != SQLITE_OK)
    {
        std::cerr << "Error in select statement " << stmt << "[" << errmsg << "]\n";
    }
    sqlite3_close(DB);

    return records;
}