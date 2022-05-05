import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { NewWord } from './newWord';
import { TableRow, wordLength } from './tableRow';
import { APP_BASE_HREF } from '@angular/common';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent {
  won: boolean = false;
  title = 'wordle';
  targetWord = '';
  guess = '';
  rows: TableRow[] = [];
  start: boolean = false;
  gamesPlayed: number = 0;
  gamesWon: number = 0;
  winStreak: number = 0;
  avgGuess: number = 0;
  guesses: number = 0;
  btnDisabledStyle: string = '';

  url = '{{APP_BASE_HREF}}/wordle_api.php';

  constructor(public HttpClient: HttpClient) {}

  getNewWord() {
    this.HttpClient.get<NewWord>(
      'https://cs4640.cs.virginia.edu/jct7bm/hw8/php/wordle_api.php'
    ).subscribe((response) => {
      if (response['status']) {
        let result: NewWord = response;
        this.targetWord = result['data'];
      }
    });
  }

  startNewGame() {
    if (!this.won) {
      this.winStreak = 0;
    }
    this.getNewWord();
    this.rows = [] as TableRow[];
    this.guess = '';
    this.start = true;
    this.won = false;
    this.gamesPlayed++;
    this.guesses = 0;
    this.btnDisabledStyle = '';
  }

  checkWord() {
    this.guesses++;
    this.calcAverage();

    if (this.guess === this.targetWord) {
      // Game won!
      this.won = true;
      this.gamesWon++;
      this.winStreak++;
      this.btnDisabledStyle = ':disabled';
    }
    this.addTableRow();
    this.guess = '';
  }

  addTableRow() {
    let newRow = new TableRow(
      this.guess,
      this.correctLetters(),
      this.correctPosition(),
      this.correctLength()
    );
    this.rows.push(newRow);
  }

  charSetArray(word: string) {
    let wordArr = new Set(word.split(''));
    let wordSet = [...wordArr].join('');
    return wordSet;
  }

  correctLetters() {
    let word = this.charSetArray(this.guess);
    let target = this.charSetArray(this.targetWord);

    let numberCorrect = 0;
    for (const char of word) {
      if (target.includes(char)) {
        numberCorrect++;
      }
    }
    return numberCorrect;
  }

  correctPosition() {
    let word = this.charSetArray(this.guess);
    let target = this.charSetArray(this.targetWord);

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

  correctLength() {
    let word = this.guess;
    let target = this.targetWord;

    if (word.length < target.length) {
      return wordLength.short;
    }
    if (word.length > target.length) {
      return wordLength.long;
    }
    return wordLength.same;
  }

  clearHistory() {
    this.rows = [] as TableRow[];
    this.gamesPlayed = 0;
    this.gamesWon = 0;
    this.avgGuess = 0;
    this.gamesPlayed = 0;

    this.startNewGame();
  }

  calcAverage() {
    if (this.gamesPlayed > 0) {
      this.avgGuess =
        (this.avgGuess * (this.gamesPlayed - 1) + this.guesses) /
        this.gamesPlayed;
    } else {
      this.avgGuess = 0;
    }
  }
}
