import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

/**
 * Guard fonctionnel — protège les routes qui nécessitent une connexion.
 * Si non connecté → redirige vers /connexion.
 */
export const authGuard: CanActivateFn = () => {
  const auth   = inject(AuthService);
  const router = inject(Router);

  if (auth.estConnecte()) return true;

  return router.createUrlTree(['/connexion']);
};
