#pragma once

#include <iostream>
#include <filesystem>
#include <vector>
#include <fstream>
#include <Windows.h>
#include "Entry.h"
#include <sqlite3.h>

static const char* DIR = "C:\\dienynas\\database\\dienynas.db";
static const char* PATH = "C:\\dienynas\\DATA";


namespace fs = std::filesystem;
using namespace std;

using Record = std::vector<std::string>;
using Records = std::vector<Record>;

//Regular functions
void ReadDir(vector<string>& files);
void ReadFiles(vector<Entry>& entries, vector <string>& files);
void Print(vector <Entry>& entries);
void DeleteDirectoryContents();
bool Student_exists(Entry entry, int& ID);
void WriteToDB(vector<Entry>& entries);

//SQL functions
Records Select_stmt(string stmt);
void Insert_stmt(string stmt);
int select_callback(void* p_data, int num_fields, char** p_fields, char** p_col_names);