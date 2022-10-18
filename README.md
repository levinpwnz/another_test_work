# Test for PHP programmer

Description:
You have 4 tables - users , posts , comments

User has right to do CRUD with post and comments which means any user can create any post and leave any comment under any post.
But , only owner of the post or the comment has right to update it or delete it , other users have no right to update and delete others’ posts or comments

Requirements:
1. Do it using Laravel Framework , version 9
2. Database should be Postgres

Endpoints:
1. GET /api/users should return all users with posts and all comments which the current user left under any post

2. GET /api/posts should return all posts belong to current user and all comments of each user

3. POST /api/posts

4. POST /api/comments

Bonus:
writing Unit tests
using TDD methodology
