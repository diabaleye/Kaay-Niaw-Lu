import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Header } from '../header/header';

@Component({
  selector: 'app-parametres',
  standalone: true,
  imports: [CommonModule, Header],
  templateUrl: './parametres.html',
  styleUrl: './parametres.css'
})
export class Parametres {}