export type RoleUtilisateur = 'client' | 'tailleur' | 'admin';

export interface ProfilTailleur {
  id: number;
  nom_atelier: string | null;
  ville: string | null;
  localisation: string | null;
  specialites: string | null;
  commandes_max_semaine: number;
  delai_moyen_jours: number | null;
  statut_validation: 'en_attente' | 'valide' | 'refuse';
  note_moyenne: number;
  nombre_avis: number;
}

export interface User {
  id: number;
  nom: string;
  email: string;
  telephone: string;
  role: RoleUtilisateur;
  profil_tailleur?: ProfilTailleur | null;
  cree_le: string;
}

export interface AuthResponse {
  message: string;
  token: string;
  user: User;
}

export interface InscriptionClientPayload {
  prenom: string;
  nom: string;
  email: string;
  telephone: string;
  password: string;
  password_confirmation: string;
}

export interface InscriptionTailleurPayload extends InscriptionClientPayload {
  nom_atelier: string;
  localisation: string;
  specialites?: string;
  commandes_max_semaine: number;
  delai_moyen_jours?: number;
}

export interface ConnexionPayload {
  telephone: string;
  password: string;
}
