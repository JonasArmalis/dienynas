#include "Functions.h"

/*
    The main loop of the program

*/

int main()
{
    vector <string> files;
    vector <Entry> entries;

    while (true)
    {
        // If the directory isn't empty, then read all the files and and write the data to DB
        if (!fs::is_empty(PATH))
        {
            ReadDir(files);
            ReadFiles(entries, files);
            Print(entries);
            DeleteDirectoryContents();
            files.erase(files.begin(), files.end());
            WriteToDB(entries);
            entries.erase(entries.begin(), entries.end());
        }

        Sleep(5000);
    }

    return 0;
}