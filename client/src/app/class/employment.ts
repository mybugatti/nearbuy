import {Entreprise} from "./entreprise";
import {User} from "./user";

export class Employment {
  id: number;
  entreprise: Entreprise;
  user: User;
  role: string;
}
