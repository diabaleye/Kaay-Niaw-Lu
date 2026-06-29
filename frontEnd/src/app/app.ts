import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { Aside } from './components/aside/aside';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, Aside],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  title = 'kaaay-niaw-lou';
}