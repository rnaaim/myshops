Shops
-----
An application that shows user a list of nearby shops and offer the posibilty to like or dislike them

Installation
------------

  * *Requirements*:
       - Php 7
       - Composer : https://getcomposer.org/download/
       - MongoDB 3.4 : https://docs.mongodb.com/manual/installation/
       - Mongo-php-library : https://github.com/mongodb/mongo-php-library
       
  * Project database :

	- In terminal,run : `mongorestore --db shops shops/`
	  This will create a database named shops with two collections shops and users.

		
    
  * To run the project :
  
      - git clone https://github.com/rnaaim/myshops.git 
      - Inside the project directory run `composer install` to install all required dependecies.
      - Go to app/config and create new file parameters.yml
      - Copy content from parameters.yml.dist to parameters.yml
      - Generate new private and public keys for our authentication bundle https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#configuration
      - Update the location of public and private keys in /app/config/config.yml under the lexik_jwt_authentication section
       - Add two parameters at the end of parameters.yml :
		`mongodb_server: "mongodb://localhost:27017"`
                `jwt_key_pass_phrase: *passe phrase entered during keys generatoin*`
       - To run the applicatoin : ./bin/console server:start
