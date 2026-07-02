import { inject } from '@angular/core';
import { CanActivateFn, ActivatedRouteSnapshot, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

/**
 * Guard de rôle — usage dans les routes :
 *   { path: 'client', canActivate: [authGuard, roleGuard], data: { role: 'client' } }
 */
export const roleGuard: CanActivateFn = (route: ActivatedRouteSnapshot) => {
  const auth   = inject(AuthService);
  const router = inject(Router);
  const role   = route.data['role'] as string;

  if (auth.user()?.role === role) return true;

  // Rediriger vers le bon tableau de bord si connecté mais mauvais rôle
  auth.redirigerSelonRole();
  return false;
};
