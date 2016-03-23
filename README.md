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