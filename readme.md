![Alt text](./public/images/logo.png?raw=true "Title")

Musicall is a simple mp3 player with some voice recognition functions.

## Installation
1. Move the project to C:\xampp\htdocs (in case you use XAMPP Apache Server/MySQL) and Import db_music.sql into phpMyAdmin.

2. rename .env.example to .env or generate your own one with your credentials.

3. Copy your .mp3 music into /musiCall/public/music folder

4. Access to "http://localhost/musiCall.

5. Click "Upload Songs" Button.

* In case of errors:

   1. Open Windows CMD and run next commands:
   2. cd C:\xampp\htdocs\musiCall
   3. composer update (optional)
   4. php artisan cache:clear
   5. php artisan key:generate
   6. php artisan config:cache


### Requirements
* XAMPP - Apache/MySQL
* Composer (optional)

## Usage

* Clicking the microphone (select language before) you can call some actions like:

   1. "play" - Reproduce the selected track.
   2. "stop" - Stops the track.
   3. "next" - Plays the next song.
   4. "back" - Plays the previous song.

There are more actions but they are in a testing phase.   