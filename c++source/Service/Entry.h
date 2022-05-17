#pragma once
#include <string>

using namespace std;

class Entry
{

public:
	//Constructors/Destructors
	Entry(string, string , string , string, int, string);
	~Entry();

	//Functions 
	//Setters
	void SetName(string);
	void SetSurname(string);
	void SetSubject(string);
	void SetGrade(int);
	void SetMsg(string);
	//Getters
	string GetName();
	string GetSurname();
	string GetSubject();
	string GetClass();
	string GetMsg();
	int GetGrade();

private:
	string clas;
	string name;
	string surname;
	string subject;
	string msg;
	int grade;

	
};