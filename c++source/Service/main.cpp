#include "Functions.h"

/*
    The main loop of the program

*/
const char* DIR = "C:\\dienynas\\database\\dienynas.db";
const char* PATH = "C:\\dienynas\\DATA";

int main()
{
    vector <string> files;
    vector <Entry> entries;

    while (true)
    {
        // If the directory isn't empty, then read all the files and and write the data to DB
        if (!fs::is_empty(PATH))
        {
            ReadDir(files, PATH);
            ReadFiles(entries, files);
            Print(entries);
            DeleteDirectoryContents(PATH);
            files.erase(files.begin(), files.end());
            WriteToDB(entries, DIR);
            entries.erase(entries.begin(), entries.end());
        }

        Sleep(5000);
    }

    return 0;
}