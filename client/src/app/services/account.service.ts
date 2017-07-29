/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { User } from '../class/user'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import {OAuthService} from "angular-oauth2-oidc";

@Injectable()
export class AccountService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'account';
    }


    getAccount(): Promise<User[]>{
        return this.http.get(this.getEntityUrl(), {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    update(user: User): Promise<User>{
        const url = `${this.getEntityUrl()}/${user.id}`;
        return this.http
            .put(url, this.serialize(user), {headers: this.headers})
            .toPromise()
            .then(() => user)
            .catch(this.handleError);
    }

    remove(): Promise<void> {
        const url = `${this.getEntityUrl()}`;
        return this.http.delete(url, {headers: this.headers})
            .toPromise()
            .then(() => null)
            .catch(this.handleError);
    }
}