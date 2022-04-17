#include <iostream>
#include <string>
#include <sqlite3.h>

using namespace std;

void ExecuteSql(const char* DIR, string sql);

int main()
{
    const char* DIR = "C:\\dienynas\\database\\dienynas.db";

    //CreateDB(DIR);

    string sqlCreateStudentsTable = "CREATE TABLE students("
        "ID INTEGER PRIMARY KEY AUTOINCREMENT, "
        "name      TEXT NOT NULL, "
        "surname   TEXT NOT NULL );";

    string sqlCreateGradesTable = "CREATE TABLE grades("
        "ID INTEGER PRIMARY KEY AUTOINCREMENT, "
        "studentID      INTEGER NOT NULL,"
        "subject        TEXT NOT NULL,"
        "grade          INTEGER NOT NULL);";

    string sqlInsert = "INSERT INTO students (ID, name, surname)"
       "VALUES(NULL, 'Jonas', 'Armalis');";


    //ExecuteSql(DIR, sqlCreateStudentsTable);
    //ExecuteSql(DIR, sqlCreateGradesTable);
    ExecuteSql(DIR, sqlInsert);

    return 0;
}


void ExecuteSql(const char* DIR, string sql)
{
    sqlite3* DB;

    try
    {
        int exit = 0;
        exit = sqlite3_open(DIR, &DB);

        char* error;
        exit = sqlite3_exec(DB, sql.c_str(), NULL, 0, &error);

        if (exit != SQLITE_OK)
        {
            cout << error  << endl;
            sqlite3_free(error);
        }
        else
            cout << "Table created successfully" << endl;
        sqlite3_close(DB);

    }
    catch (const exception& e)
    {
        cout << e.what() << endl;
    }
}