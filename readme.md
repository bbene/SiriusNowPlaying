#Description
SiriusNowPlaying is a php daemon that checks the current track of the Liquid Metal channel and updates a HipChat
room with the current track information.  This is useful if you are using it in a team environment and want to update
users on the current track.

#Usage
1. Clone the repository 
    `git clone https://git@github.com:bbene/SiriusNowPlaying.git`
2. cd to the project
    `cd SiriusNowPlaying`
3. Edit main.php with your HipChat API key.
4. Run composer `composer install`
5. Run the daemon `php main.php`

#Planned Features
-	Choose which station to use.
-	Have more? Create an issue or pull request.