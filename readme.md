BIG WARNING!!!! I DID THIS BECAUSE I DECIDED TO JUST INSTALL SASS/BOOTSTRAP ONTO MY COMPUTER
AND I SUGGEST YOU DO SO ASWELL (not forcing u to do so tho since i am configuring the stuff
on my end too so technically you dont have to do anything :3) READ THE COMMENTS IN THE "sass/
main.scss" FILE BECAUSE THOSE ARE GONNA BE REALLY HELPFUL

thats all thank you :3


# big boy updates

added new variables you can see in main css

primary is now the primary pink 
secondary is now the secondary pinkk

added custom position variables

n5px for -5px
60px for 60px
28px for (you'll never guess) 28px!

# database

sa xampp press the shell sa right hand side
then in that terminal type:
    cd mysql/bin
    mysql -u root -p

when it asks for your password just press enter

then do the following V

create database gym_database;


# first table in the database

```
create table user_accounts(
    id int NOT NULL AUTO_INCREMENT,
    full_name varchar(100) NOT NULL UNIQUE,
    email varchar(100) NOT NULL UNIQUE,
    username varchar(100) NOT NULL UNIQUE,
    password varchar(100) NOT NULL,
    gender enum("Male", "Female"),
    membership enum("Daily","10_Days","2_Weeks","Monthly"),
    PRIMARY KEY (id)
);

create table sessions(
    id int not null,
    duration_sess int not null,
    date date,
    payment_status enum('Paid', 'Unpaid'),
    foreign key (id) references user_accounts (id)
);

create table transactions(
    id int not null,
    payment int not null,
    foreign key (id) references user_accounts (id)
);
```


#this is not finished yet because i forgot to add this initially sorry

create table user_activity(
    id int,
    day date,
    activity enum()
);
