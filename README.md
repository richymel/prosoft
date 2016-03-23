# prosoft
Prosoft exercise

Start time: 21:00 BOLIVIAN TIME

1st Deployment: 21:53
	- Input is masked (formatted) and validated
 	- Parameters are passed to PHP from input form
 	- PHP generates calendar months as needed

 	BUGS AND PENDING ISSUES:
 		- Weekends are not calculated and rendered correctly.
 		- End date needs to be calculated and detected during calendar month rendering.

2nd Deployment: 22:42
	- End date is now calculated and detected during calendar rendering.
	- Several months are calculated correctly.

	BUGS:
	- Year rollover is not handled correctly.
	- Last day on year rollover fails.
	- Weekends are not calculated and rendered correctly.

3rd Deployment: 23:28

	- Fixed weekend display
	- Fixed yr rollover
	- Rollover last day fixed


a. A list of any requirements you could not implement.

	- Holiday info


b. Bugs you’ve identified but didn’t have time to fix.

	- Input date validation

c. Things you would do if you had more time to complete the task.

	- Holiday info
