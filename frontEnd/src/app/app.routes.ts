import { Routes } from '@angular/router';
import { CalendrierLivraisons } from './components/calendrier-livraisons/calendrier-livraisons';
import { Parametres } from './components/parametres/parametres';

export const routes: Routes = [
  { path: '', redirectTo: 'calendrier', pathMatch: 'full' },
  { path: 'calendrier', component: CalendrierLivraisons },
  { path: 'parametres', component: Parametres },
];