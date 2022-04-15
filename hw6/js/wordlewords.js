/**
 * This function will query the CS4640 server for a new word.
 *
 * It makes use of AJAX and Promises to await the result.
 */
function queryWord() {
  return new Promise((resolve) => {
    // instantiate the object
    var ajax = new XMLHttpRequest();
    // open the request
    ajax.open("GET", "https://cs4640.cs.virginia.edu/api/wordleword.php", true);
    // ask for a specific response
    ajax.responseType = "text";
    // send the request
    ajax.send(null);

    // What happens if the load succeeds
    ajax.addEventListener("load", function () {
      // Return the word as the fulfillment of the promise
      if (this.status == 200) {
        // worked
        resolve(this.response);
      } else {
        console.log(
          "When trying to get a new word, the server returned an HTTP error code."
        );
      }
    });

    // What happens on error
    ajax.addEventListener("error", function () {
      console.log(
        "When trying to get a new word, the connection to the server failed."
      );
    });
  });
}

/**
 * This is the function you should call to request a new word.
 * It takes one parameter: a callback function.  This function
 * should take one parameter (the new word) and handle the setup
 * of your new game.  For example if you have a function named
 * setUpNewGame(newWord), then in your event handler for a new
 * game, you should call this function as:
 *     getRandomWord(setUpNewGame);
 * It will wait for the server to provide a new word, then it will
 * call your function, passing in the word, to continue setting up
 * the new game.
 */
async function getRandomWord(callback) {
  var newWord = await queryWord();
  callback(newWord);
}

function newGame(newWord) {
  game = {
    target: newWord,
    guesses: [],
  };
  window.localStorage.setItem("game", JSON.stringify(game));
}

function loadGame(game) {}

function startGame(game) {
  let input = document.getElementById("guess-input");
  input.style.visibility = "visible";

  let guessTable = document.getElementById("guess-table");
  if (typeof game.guesses !== "undefined" && game.guesses.length > 0) {
    fillTable(game.guesses, game.target);
  }
  guessTable.style.visibility = "visible";
}

function fillTable(guesses, target) {
  for (const guess of guesses) {
    addTableRow(guess, target);
  }
  document.getElementById("guess-table").style.visibility = "visible";
}

function addTableRow(guess, target) {
  let table = document.getElementById("guess-table");
  let row = table.insertRow(1);
  let cell1 = row.insertCell(0);
  let cell2 = row.insertCell(1);
  let cell3 = row.insertCell(2);
  let cell4 = row.insertCell(3);

  let guessSet = charSetArray(guess);
  let targetSet = charSetArray(target);
  cell1.innerText = guess;
  cell2.innerText = correctLetters(guessSet, targetSet);
  cell3.innerText = correctPosition(guess, target);
  cell4.innerText = correctLength(guess, target);
}

function correctLength(word, target) {
  if (word.length < target.length) {
    return "too short";
  }
  if (word.length > target.length) {
    return "too long";
  }
  return "same length";
}

function correctLetters(word, target) {
  let numberCorrect = 0;

  for (const char of word) {
    if (target.includes(char)) {
      numberCorrect++;
    }
  }
  return numberCorrect;
}

function correctPosition(word, target) {
  let numberCorrect = 0;
  for (let i = 0; i < target.length; i++) {
    if (i >= word.length) {
      break;
    }
    if (word[i] === target[i]) {
      numberCorrect++;
    }
  }
  return numberCorrect;
}

function charSetArray(word) {
  let wordArr = new Set(word.split(""));
  wordArr = [...wordArr].join("");
  return wordArr;
}

function loadUser() {
  let game = JSON.parse(window.localStorage.getItem("game"));
  let stats = JSON.parse(window.localStorage.getItem("stats"));

  if (stats === null) {
    // Brand new user
    stats = newUser();
    window.localStorage.setItem("stats", JSON.stringify(stats));
  } else {
    stats = JSON.parse(window.localStorage.getItem("stats"));
  }
  loadStats(stats);
  if (game === null) {
    // do nothing for now
  } else {
    game = JSON.parse(window.localStorage.getItem("game"));
    startGame(game);
  }
}

function saveUser(stats, game = null) {
  window.localStorage.stats = JSON.stringify(stats);
  window.localStorage.game = JSON.stringify(game);
}

function loadStats(stats) {
  let gamesPlayed = document.getElementById("games-played");
  let gamesWon = document.getElementById("games-won");
  let winStreak = document.getElementById("win-streak");
  let avgGuess = document.getElementById("avg-guess");
  if (stats === null) {
    gamesPlayed.innerText = 0;
    gamesWon.innerText = 0;
    winStreak.innerText = 0;
    avgGuess.innerText = 0;
  } else {
    gamesPlayed.innerText = stats.gamesPlayed;
    gamesWon.innerText = stats.gamesWon;
    winStreak.innerText = stats.winStreak;
    avgGuess.innerText = calcAverage(stats.gamesPlayed, stats.guesses);
  }
  document.getElementById("stats-div").style.visibility = "visible";
}

function newUser() {
  let stats = {
    gamesPlayed: 0,
    gamesWon: 0,
    winStreak: 0,
    guesses: 0,
  };
  return stats;
}

function calcAverage(gamesPlayed, guesses) {
  if (gamesPlayed > 0) {
    return guesses / gamesPlayed;
  } else {
    return 0;
  }
}

function startNewGame() {
  document.getElementById("submit-guess").disabled = false;
  document.getElementById("guess-input-field").disabled = false;
  let stats = JSON.parse(window.localStorage.getItem("stats"));
  if (stats === null) {
    loadUser();
    stats = JSON.parse(window.localStorage.getItem("stats"));
  }
  if (window.localStorage.getItem("game") !== null) {
    let oldGame = JSON.parse(window.localStorage.getItem("game"));
    //stats.guesses += oldGame.guesses.length;
    if (oldGame.guesses.length > 0) {
      if (oldGame.guesses[0] !== oldGame.target) {
        stats.winStreak = 0;
        stats.guesses = 0;
      }
    } else {
      stats.winStreak = 0;
      stats.guesses = 0;
      stats.gamesPlayed++;
    }
  }

  window.localStorage.setItem("stats", JSON.stringify(stats));

  document.getElementById("win-alert").style.display = "none";
  deleteAllRows();
  let game = getRandomWord(newGame);
  saveUser(stats, game);
  loadUser();
  loadStats(stats);
  startGame(game);
}

function checkWord() {
  let input = document.getElementById("guess-input-field");
  let word = input.value;
  word = word.toLowerCase();
  let game = JSON.parse(window.localStorage.getItem("game"));
  game.guesses.unshift(word);
  if (word === game.target) {
    // Game Won, do clean up
    let stats = JSON.parse(window.localStorage.getItem("stats"));
    stats.gamesPlayed++;
    stats.gamesWon++;
    stats.winStreak++;
    stats.guesses += game.guesses.length;
    window.localStorage.setItem("stats", JSON.stringify(stats));
    let alert = document.getElementById("win-alert");
    alert.style.display = "grid";
    document.getElementById("submit-guess").disabled = true;
    document.getElementById("guess-input-field").disabled = true;
    loadStats(stats);
  } else {
    addTableRow(word, game.target);
    input.value = "";
  }
  window.localStorage.setItem("game", JSON.stringify(game));
  document.getElementById("guess-input-field").value = "";
}

function deleteAllRows() {
  let table = document.getElementById("guess-table");
  for (var i = 1; i < table.rows.length; ) {
    table.deleteRow(i);
  }
}

function clearHistory() {
  window.localStorage.clear();
  deleteAllRows();
  document.getElementById("stats-div").style.visibility = "hidden";
  document.getElementById("guess-input-field").value = "";
  startNewGame();
}

loadUser();
