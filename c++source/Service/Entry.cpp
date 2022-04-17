#include "Entry.h"

Entry::Entry(string name, string surname, string subject, int grade)
{
	this->grade = 0;
	this->name = name;
	this->surname = surname;
	this->subject = subject;
	this->grade = grade;
}

Entry::~Entry()
{
}

void Entry::SetName(string val)
{
	this->name = val;
}

void Entry::SetSurname(string val)
{
	this->surname = val;
}
void Entry::SetSubject(string val)
{
	this->subject = val;
}

void Entry::SetGrade(int val)
{
	this->grade = val;
}

string Entry::GetName()
{
	return this->name;
}

string Entry::GetSurname()
{
	return this->surname;
}

string Entry::GetSubject()
{
	return this->subject;
}

int Entry::GetGrade()
{
	return this->grade;
}