/*
  Dynamic Table Help: https://www.positronx.io/build-dynamic-html-table-in-angular-with-ngfor/
  Angular Docs: https://angular.io/
  Angular Guide I used: https://www.educative.io/path/become-an-angular-js-developer
*/
import { HttpClientModule } from '@angular/common/http';
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppComponent } from './app.component';
import { FormsModule } from '@angular/forms';

@NgModule({
  declarations: [AppComponent],
  imports: [BrowserModule, HttpClientModule, FormsModule],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
