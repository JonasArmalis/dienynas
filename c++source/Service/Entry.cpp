#include "Entry.h"

Entry::Entry(string name, string surname, string subject, string cl, int grade, string msg)
{
	this->grade = 0;
	this->name = name;
	this->surname = surname;
	this->subject = subject;
	this->clas = cl;
	this->grade = grade;
	this->msg = msg;
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

void Entry::SetMessage(string val)
{
	this->msg = val;
}

string Entry::GetMessage()
{
	return this->msg;
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

string Entry::GetClass()
{
	return this->clas;
}

int Entry::GetGrade()
{
	return this->grade;
}