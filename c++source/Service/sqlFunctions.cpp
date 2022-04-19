#include "Functions.h"

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