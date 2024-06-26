# Word Game

This repository contains a simple PHP-based word game where players can form words from a set of randomly generated letters. High scores are tracked using PHP sessions without the need for a database.

## Solution Overview

### Features

- **Game Start:** Players start the game by generating a unique set of letters.
- **Word Submission:** Players can submit valid English words formed from the available letters.
- **Score Calculation:** Each word's score is determined by its length.
- **End Game:** Players can end the game, which clears all session data and displays all words with their scores in a table format.
- **Bootstrap Design:** Implemented using Bootstrap 4 for responsive and clean UI.

### Why This Approach

- **Session Management:** PHP sessions (`$_SESSION`) are used for storing game state and high scores, providing a simple and effective way to maintain data across game pages without a database.

- **Bootstrap Integration:** Bootstrap is utilized for frontend styling to enhance user experience and ensure a modern interface.

## Setup Instructions

### Prerequisites

1. **Web Server**: A local web server like Apache or Nginx.
2. **PHP**: PHP 7.4 or higher.
   
To run the PHP word game locally or on your server, follow these steps:

1. **Clone Repository:**
   ```bash
   git clone https://github.com/vigneshrajramesh/word-game.git
