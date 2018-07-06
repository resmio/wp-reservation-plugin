# Readme



## Setup Development Environment

To create a development environment use

    docker-compose up
    
Afterwards visit http://localhost:8080


## Release new Version

1) Checkout the existing version from wordpress

    mkdir resmio-button-and-widget
    svn co https://plugins.svn.wordpress.org/resmio-button-and-widget resmio-button-and-widget

2) Adjust whatever you want in `trunk`

3) Create a new version folder in the `tags` sub directory, e.g 1.3

4) Copy everything from trunk to that new version directory

5) Commit and push everything to svn

svn ci -m 'Some Message' --username Philipp-resmio --password PasswordFromLastPass



One can check out the official instructions here:

https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/