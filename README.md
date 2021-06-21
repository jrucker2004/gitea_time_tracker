# gitea_time_tracker
A simple way to visualize time logged in gitea issues

## Database Configuration
Create a new mysql database on your gitea instance, and create a view in that database.  This view will be used to populate all of the pages.

```
CREATE VIEW time_track_view AS
select
 r.id as repo_id,
 r.name as repo_name,
 p.id as project_id,
 p.title as project_title,
 t.issue_id as issue_id,
 i.name as issue_name,
 t.time as logged_time,
 t.created_unix
from
 gitea.tracked_time t,
 gitea.issue i,
 gitea.project p,
 gitea.repository r
where t.issue_id = i.id
 and r.id = i.repo_id
 and r.id = p.repo_id
```


