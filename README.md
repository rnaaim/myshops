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

		
    
  * To init the project :
  
      - git clone https://github.com/rnaaim/myshops.git 
      - Inside the project directory run `composer install` to install all required dependecies.
	- create file : parameters.yml with default paramaters from  parameters.yml.dist and add these two at the end :
				mongodb_server: "mongodb://localhost:27017"
                                jwt_key_pass_phrase: passephrase ( this is the passe phrase you enter when generating SSH keys for LexikJWTAuthenticationBundle ( https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#configuration)

	- To run the applicatoin : ./bin/console server:start
