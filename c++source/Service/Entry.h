#pragma once
#include <string>

using namespace std;

class Entry
{

public:
	//Constructors/Destructors
	Entry(string, string , string , string, int);
	~Entry();

	//Functions

	//Setters
	void SetName(string);
	void SetSurname(string);
	void SetSubject(string);
	void SetGrade(int);

	//Getters
	string GetName();
	string GetSurname();
	string GetSubject();
	string GetClass();
	int GetGrade();




private:
	string clas;
	string name;
	string surname;
	string subject;
	int grade;

	
};