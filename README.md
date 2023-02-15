# My Planner Project

## Purpose

My Planner is a personal project that allows users to keep track of their schoolwork. I wanted to create this mainly as a way to stay on top of my assignments in the purest way possible, with the simplicity that an app like this provides. [As of 08/03/2022 My Planner is finally online!](https://myplannerko.000webhostapp.com/index.php) Note: Hostinger (the hosting service for MyPlanner) often experiences significant downtime at their free tier. The website may have trouble loading at times.

## Functionality

How does it work? Well, users can start by creating an account in My Planner. Upon account creation, users have to choose their starting semester (Spring, Summer, Fall) along with the year. After doing so, users can create their courses and assignments for said courses. On the homepage, users can see all of their assignments that are due in the next 30 days. The tasks page is brains of the site, allowing users to edit assignments to show completion status, edit their contents, as well as create/edit more courses and semesters. The schedule page shows all of the user's classes throughout the week (Mon-Fri) for the current semester. If a day has more than one class, those classes are ordered by their start time.

## Technical Details

My Planner utilizes the skillset I learned while pursuing my Associates degree and also some tech I had to learn while creating this project. My Planner uses AJAX and PHP to interact with a MySQL database without refreshing the page, allowing for a better user experience as the page doesn't have to be reloaded or sent somewhere else. The database that My Planner runs on has full auditing, allowing devs to track sensitive information and any other database changes. My Planner doesn't utilize any frameworks and was created in pure JavaScript, PHP, MySQL, CSS, and HTML.
