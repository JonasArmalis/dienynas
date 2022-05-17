#pragma once

#include <iostream>
#include <filesystem>
#include <vector>
#include <fstream>
#include <Windows.h>
#include "Entry.h"
#include <sqlite3.h>


namespace fs = std::filesystem;
using namespace std;

using Record = std::vector<std::string>;
using Records = std::vector<Record>;

//Regular functions
void ReadDir(vector<string>& files, const char* PATH);
void ReadFiles(vector<Entry>& entries, vector <string>& files);
void Print(vector <Entry>& entries);
void DeleteDirectoryContents(const char* PATH);
bool Student_exists(Entry entry, int& ID, const char* DIR);
bool Class_exists(string clas, int& ID, const char* DIR);
void WriteToDB(vector<Entry>& entries, const char* DIR);

//SQL functions
Records Select_stmt(string stmt, const char* DIR);
void Insert_stmt(string stmt, const char* DIR);
int select_callback(void* p_data, int num_fields, char** p_fields, char** p_col_names);