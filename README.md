Commission fee calculator app
About the task
Some bank allows private and business clients to deposit and withdraw funds to and from accounts in multiple currencies. Clients may be charged a commission fee.

You have to create an application that handles operations provided in CSV format and calculates a commission fee based on defined rules.

Commission fee calculation
Commission fee is always calculated in the currency of the operation. For example, if you withdraw or deposit in US dollars then commission fee is also in US dollars.
Commission fees are rounded up to currency's decimal places. For example, 0.023 EUR should be rounded up to 0.03 EUR.
Deposit rule
All deposits are charged 0.03% of deposit amount.

Withdraw rules
There are different calculation rules for withdraw of private and business clients.

Private Clients

Commission fee - 0.3% from withdrawn amount.
1000.00 EUR for a week (from Monday to Sunday) is free of charge. Only for the first 3 withdraw operations per a week. 4th and the following operations are calculated by using the rule above (0.3%). If total free of charge amount is exceeded them commission is calculated only for the exceeded amount (i.e. up to 1000.00 EUR no commission fee is applied).
For the second rule you will need to convert operation amount if it's not in Euros. Please use rates provided by api.exchangeratesapi.io.

runningthe script
composer dump-autoload
php index.php input.cvs
