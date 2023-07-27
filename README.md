# Cows and Bulls Game

The Cows and Bulls Game is a simple web-based guessing game where the player tries to guess a randomly generated 4-digit number. The game has specific rules and limitations for the digits used in the generated number to add an extra level of challenge and fun.

## Build technologies

- **PHP** language 8.* version
- **Laravel** framework v.7 | v.8
- **MySQL** database
- **Bootstrap** (for styling)

## Game Rules

1. The player needs to guess a 4-digit number.
2. Each digit in the number should be unique (no repeating digits).
3. The generated 4-digit number has the following limitations:
- Digits 1 and 8 should be right next to each other (e.g., 18, 81).
- Digits 4 and 5 should not be on even index/position (odd-indexed positions are allowed).

## Game Play

1. When the player starts the game, a random 4-digit number meeting the rules will be generated and stored in the session.
2. The player can enter their guess for the number in a form field on the game page.
3. After submitting the guess, the game will display the number of "cows" and "bulls" in the player's guess.
- "Cows" are digits that are present in the generated number but in different positions in the player's guess.
- "Bulls" are digits that are present in the correct positions in the player's guess.
4. The player continues guessing until they correctly guess the entire number (all 4 bulls).
5. Once the player guesses the number correctly, their score is calculated based on the number of attempts made.

## High Scores

The game keeps track of the top 10 best results (high scores) and displays them in a separate high scores page.

## Setup

Make sure you download all the dependencies (packages) required for the technology and set up the databases! Below are instructions on how to do this:

### Installation

1. Clone or download project from https://github.com/KrasimiraGeorgieva/cows-and-bulls.git
2. Copy **.env.example** file and rename it as **.env**
3. Set up a **MySQL database** and configure the database connection in the **.env** file.
4. Open the console/terminal into the root directory of the project
5. Run `composer install` command
6. Run `php artisan key:generate` 
7. Run the database migrations to create the required tables. Use `php artisan migrate` command
8. Make sure you’ve started your local server
- Configuring your local Laravel development environment(Homstead(Vagrant), Valet(macOS), XAMPP, Docker)
- To start Laravel Development server run `php artisan serve` command
9. Open the application in the browser
10. Enjoy playing the Cows and Bulls game!

## Files and Directories

- `app/Http/Controllers/GameController.php`: The main controller handling game functionality.
- `app/Models/HighScore.php`: Model for the high scores table.
- `database/migrations/*`: Migration files for creating the high scores table.
- `resources/views/game/index.blade.php`: Blade view for the game interface.
- `resources/views/game/high_scores.blade.php`: Blade view for the high scores page.
- `resources/views/layouts/app.blade.php`: Blade layout file for the main application layout.
- `public/css/*`: CSS files for styling the game interface.
- `public/js/*`: JavaScript files for handling game interactions.
- `routes/web.php`: Route definitions for the game and high scores pages.

## Notes

- This game was developed for learning purposes and follows the given requirements of having Laravel 8 as the base framework.
Enjoy playing the **Cows and Bulls** game! If you have any questions or feedback, feel free to reach out. **Happy gaming!**

