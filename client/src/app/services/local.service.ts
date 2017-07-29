/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Local } from '../class/local'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import {OAuthService} from "angular-oauth2-oidc";

@Injectable()
export class LocalService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'local';
    }

    getLocals(): Promise<Local[]>{
        return this.http.get(this.getEntityUrl()+"s", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    getLocal(id : number): Promise<Local> {

        return this.http.get(this.getEntityUrl()+"/"+id+".json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    create(local : Local): Promise<Local> {
        return this.http
            .post(this.getEntityUrl(), this.serialize(local), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    update(local : Local): Promise<Local>{
        const url = `${this.getEntityUrl()}/${local.id}`;
        return this.http
            .put(url, this.serialize(local), {headers: this.headers})
            .toPromise()
            .then(() => local)
            .catch(this.handleError);
    }

    remove(id : number): Promise<void> {
        const url = `${this.getEntityUrl()}/${id}`;
        return this.http.delete(url, {headers: this.headers})
            .toPromise()
            .then(() => null)
            .catch(this.handleError);
    }
}