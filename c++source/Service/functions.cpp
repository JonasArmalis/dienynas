#include "Functions.h"

void ReadDir(vector<string>& files)
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

void DeleteDirectoryContents()
{
    for (const auto& entry : fs::directory_iterator(PATH))
        fs::remove_all(entry.path());
}

void WriteToDB(vector<Entry>& entries)
{
    for (auto& entry : entries)
    {
        int student_ID = -1;
        //If a student already exists, then we only insert the grade into the grades table
        if (Student_exists(entry, student_ID))
        {

            string insert_grade = "INSERT INTO grades (ID, studentID, subject, grade) VALUES ("
                "NULL, '"
                + to_string(student_ID) + "', '"
                + entry.GetSubject() + "', '"
                + to_string(entry.GetGrade()) + "');";

            Insert_stmt(insert_grade);
        }
        //If a student doesn't exist, then insert the student and the grade
        else
        {
            string create_student = "INSERT INTO students (ID, name, surname) VALUES ("
                "NULL, '"
                + entry.GetName() + "', '"
                + entry.GetSurname() + "');";

            Insert_stmt(create_student);
            string get_id = "SELECT ID FROM students "
                "WHERE name = '" + entry.GetName() + "' "
                "AND surname = '" + entry.GetSurname() + "' ;";

            student_ID = stoi(Select_stmt(get_id)[0][0]);

            string insert_grade = "INSERT INTO grades (ID, studentID, subject, grade) VALUES ("
                "NULL, '"
                + to_string(student_ID) + "', '"
                + entry.GetSubject() + "', '"
                + to_string(entry.GetGrade()) + "');";

            Insert_stmt(insert_grade);
        }
    }
}

//Checks whether a student with a given name and surname alrready exists, returns its ID
bool Student_exists(Entry entry, int& ID)
{
    string select_students = "SELECT * FROM students;";
    Records students = Select_stmt(select_students);
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