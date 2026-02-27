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

create database gym_database;

create table user_accounts(
    id int NOT NULL AUTO_INCREMENT,
    full_name varchar(100) NOT NULL,
    email varchar(100) NOT NULL,
    password varchar(100) NOT NULL,
    mode_of_payment ENUMS("cash","GCash","Card)
    PRIMARY KEY (id)
);

create table user_banking_information(
    id int,
    acc_name varchar(100),
    acc_num int,
    FOREIGN KEY(id) REFERENCES user_acccounts(id)
);

create table user_transaction_log(
    id int,
    amount int,
    FOREIGN KEY (id) REFERENCES user_accounts(id)
);

#this is not finished yet because i forgot to add this initially sorry

create table user_activity(
    id int,
    day date,
    activity enum()
);