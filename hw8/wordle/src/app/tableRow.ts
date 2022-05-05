export enum wordLength {
  short = 'Too Short',
  long = 'Too Long',
  same = 'Same Length',
}

export class TableRow {
  guess: string = '';
  correctLetters: number = 0;
  correctPlacement: number = 0;
  correctLength: wordLength = wordLength.short;

  constructor(g: string, l: number, p: number, e: wordLength) {
    this.guess = g;
    this.correctLetters = l;
    this.correctPlacement = p;
    this.correctLength = e;
  }
}
