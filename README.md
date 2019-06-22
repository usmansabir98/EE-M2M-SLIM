
# M2M Connect; SMS and PHP Processing

## Core Objectives
This coursework specification is designed to enable you to achieve the following module learning objectives:

    1. Can design and implement a web application that is impervious to the most common web-based attacks
    2. Can design and implement a web application that accesses and displays data from remote web services

## Required Technologies 

SLIM - A micro-framework used to develop robust web applications using PHP.

MySQL - Database

## Main Objectives

1. The EE-SMS server accepts SMS/GPRS messages and stores them in an XML format. 

2. The EE M2M Connect services allows you to download these messages via the EE-SOAP server. 

3. Once downloaded, the message can be parsed and important information be extracted, sanitised and manipulated to be stored in the local database.

4. Users can demand reports of the stores messages anytime (after successful download and storage).

5. Once an initial web-report has been created and displayed on a user’s browser, AJAX or JSON could be used to dynamically update the reporting web-page when subsequent messages are downloaded and processed. Emails or SMS messages could notify users of the arrival of a message; numerical data such as temperatures could be displayed as a chart, SMS messages could be used to update the status of the circuit board (this will be a simulation).

6. Format of the message string: XML, Plain Text, Compacted Bit String.




