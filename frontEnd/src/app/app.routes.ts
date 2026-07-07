import { Routes } from '@angular/router';
import { AccueilComponent } from './pages/accueil/accueil.component';
import { AProposComponent } from './pages/a-propos/a-propos.component';
import { ContactComponent } from './pages/contact/contact.component';
import { ConnexionComponent } from './pages/connexion/connexion.component';
import { InscriptionRoleComponent } from './pages/inscription-role/inscription-role.component';
import { InscriptionClientComponent } from './pages/inscription-client/inscription-client.component';
import { InscriptionTailleurComponent } from './pages/inscription-tailleur/inscription-tailleur.component';
import { TableauDeBordComponent as TailleurDashboard } from './pages/tailleur/tableau-de-bord/tableau-de-bord.component';
import { CommandesComponent as TailleurCommandes } from './pages/tailleur/commandes/commandes.component';
import { CalendrierComponent } from './pages/tailleur/calendrier/calendrier.component';
import { AtelierComponent } from './pages/tailleur/atelier/atelier.component';
import { MessagerieComponent as TailleurMessagerie } from './pages/tailleur/messagerie/messagerie.component';
import { ParametresComponent as TailleurParametres } from './pages/tailleur/parametres/parametres.component';
import { TableauDeBordComponent as ClientDashboard } from './pages/client/tableau-de-bord/tableau-de-bord.component';
import { MesuresComponent } from './pages/client/mesures/mesures.component';
import { CommandesComponent as ClientCommandes } from './pages/client/commandes/commandes.component';
import { MessagerieComponent as ClientMessagerie } from './pages/client/messagerie/messagerie.component';
import { ParametresComponent as ClientParametres } from './pages/client/parametres/parametres.component';

export const routes: Routes = [
  { path: '', component: AccueilComponent },
  { path: 'a-propos', component: AProposComponent },
  { path: 'contact', component: ContactComponent },
  { path: 'connexion', component: ConnexionComponent },
  { path: 'inscription', component: InscriptionRoleComponent },
  { path: 'inscription/client', component: InscriptionClientComponent },
  { path: 'inscription/tailleur', component: InscriptionTailleurComponent },
  { path: 'tailleur/tableau-de-bord', component: TailleurDashboard },
  { path: 'tailleur/commandes', component: TailleurCommandes },
  { path: 'tailleur/calendrier', component: CalendrierComponent },
  { path: 'tailleur/atelier', component: AtelierComponent },
  { path: 'tailleur/messagerie', component: TailleurMessagerie },
  { path: 'tailleur/parametres', component: TailleurParametres },
  { path: 'client/tableau-de-bord', component: ClientDashboard },
  { path: 'client/mesures', component: MesuresComponent },
  { path: 'client/commandes', component: ClientCommandes },
  { path: 'client/messagerie', component: ClientMessagerie },
  { path: 'client/parametres', component: ClientParametres },
  { path: '**', redirectTo: '' }
];
