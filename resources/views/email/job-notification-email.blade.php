<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
</head>
<body>
    <h1>Hello, {{ $mailData['job_owner']->name}}</h1>
    <p>Job Title: {{ $mailData['job']->title }}</p>

    <p>Applicant Details:</p>

    <p>Name: {{ $mailData['user']->name }}</p>
     <p>Email: {{ $mailData['user']->email }}</p>
      <p>Mobile: {{ $mailData['user']->mobile }}</p>
</body>
</html>