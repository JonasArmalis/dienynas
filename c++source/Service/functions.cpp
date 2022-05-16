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
            string name, surname, subject, clas, msg;
            int grade;

            in >> name >> surname >> subject >> grade>> clas;

			char c;
			in >> c;

			while (c !='\n')
			{
				msg = msg + c;
			}

            Entry container(name, surname, subject, clas, grade, msg);
            entries.push_back(container);
        }
        in.close();
    }
}

void Print(vector <Entry>& entries)
{
    system("CLS");
    for (size_t i = 0; i < entries.size(); i++)
        cout << entries[i].GetName() << " " << entries[i].GetSurname() << " " << entries[i].GetSubject() << " " << entries[i].GetGrade() << " " << entries[i].GetClass() << " "  << entries[i].GetMessage() << endl;
}

void DeleteDirectoryContents(const char* PATH)
{
    for (const auto& entry : fs::directory_iterator(PATH))
    {
        recycle_file(entry.path().u8string());
    }
       //fs::remove_all(entry.path());
}

bool recycle_file(string path) {

    std::wstring widestr = std::wstring(path.begin(), path.end());
    const wchar_t* widecstr = widestr.c_str();

    SHFILEOPSTRUCT fileOp; 
    fileOp.hwnd = NULL;
    fileOp.wFunc = FO_DELETE;
    fileOp.pFrom = widecstr;
    fileOp.pTo = NULL;
    fileOp.fFlags = FOF_ALLOWUNDO | FOF_NOERRORUI | FOF_NOCONFIRMATION | FOF_SILENT;
    int result = SHFileOperation(&fileOp);

    if (result != 0) {
        return false;
    }
    else {
        return true;
    }
}

void WriteToDB(vector<Entry>& entries, const char* DIR)
{
    for (auto& entry : entries)
    {
        int student_ID = -1;
        int class_ID = -1;
        string get_subject_id = "SELECT ID from subjects WHERE subject = '" + entry.GetSubject() + "';";
        int subject_ID = stoi(Select_stmt(get_subject_id, DIR)[0][0]);

        bool studentExists = Student_exists(entry, student_ID, DIR);
        bool classExists = Class_exists(entry.GetClass(), class_ID, DIR);


        //If a student already exists, then we only insert the grade into the grades table
        if (studentExists)
        {
            string insert_grade = "INSERT INTO grades (ID, studentID, subjectID, grade, message) VALUES ("
                "NULL, '"
                + to_string(student_ID) + "', '"
                + to_string(subject_ID) + "', '"
				+ to_string(entry.GetGrade()) + "', '"
                + to_string(entry.GetMessage()) + "');";

            Insert_stmt(insert_grade, DIR);
        }
        //If a student doesn't exist, then insert the student and the grade
        else
        {
            if (!classExists)
            {
                string insert_class = "INSERT INTO classes (ID, class) VALUES ("
                    "NULL, '" + entry.GetClass() + "'); '";

                Insert_stmt(insert_class, DIR);

                string get_class_id = "SELECT ID FROM classes WHERE class = '" + entry.GetClass() + "' ;";
                class_ID = stoi(Select_stmt(get_class_id, DIR)[0][0]);

            }
            string create_student = "INSERT INTO students (ID, name, surname, classID) VALUES ("
                "NULL, '"
                + entry.GetName() + "', '"
                + entry.GetSurname() + "', '"
                + to_string(class_ID) + "');";


            Insert_stmt(create_student, DIR);
            string get_id = "SELECT ID FROM students "
                "WHERE name = '" + entry.GetName() + "' "
                "AND surname = '" + entry.GetSurname() + "' ;";

            student_ID = stoi(Select_stmt(get_id, DIR)[0][0]);

            string insert_grade = "INSERT INTO grades (ID, studentID, subjectID, grade, message) VALUES ("
                "NULL, '"
                + to_string(student_ID) + "', '"
                + to_string(subject_ID) + "', '"
				+ to_string(entry.GetGrade()) + "', '"
				+ to_string(entry.GetMessage()) + "');";

            Insert_stmt(insert_grade, DIR);
        }
    }
}

//Checks whether a student with a given name and surname alrready exists, returns its ID
bool Student_exists(Entry entry, int& ID, const char* DIR)
{
    string select_students = "SELECT ID, name, surname FROM students;";
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

bool Class_exists(string clas, int& ID, const char* DIR)
{
    string select_classes = "SELECT * FROM classes;";
    Records classes = Select_stmt(select_classes, DIR);
    for (size_t j = 0; j < classes.size(); j++)
    {
        if (clas == classes[j][1] )
        {
            ID = stoi(classes[j][0]);
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