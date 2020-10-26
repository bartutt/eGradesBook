-- classes current year --
SELECT profiles.name, classes.name, classes.years, person.name, person.surname
FROM ((classes 
INNER JOIN profiles ON id_profile = profiles.id)
INNER JOIN person ON id_teacher = person.id)
WHERE classes.years = '2021/2022'

-- lesson plan example --
SELECT classes.name, lesson_times.time, subjects.name, class_subject.week_day, person.name, person.surname
FROM class_subject
INNER JOIN classes ON id_class = classes.id
INNER JOIN lesson_times ON id_lesson_time = lesson_times.id
INNER JOIN subjects ON id_subject = subjects.id
INNER JOIN person ON class_subject.id_teacher = person.id
WHERE classes.name = '1a'