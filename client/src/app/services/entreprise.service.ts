/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Entreprise } from '../class/entreprise'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import {OAuthService} from "angular-oauth2-oidc";

@Injectable()
export class EntrepriseService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'entreprise';
    }

    getEntreprises(): Promise<Entreprise[]>{
        return this.http.get(this.getEntityUrl()+"s", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    getEntreprise(id: number): Promise<Entreprise> {
        return this.http.get(this.getEntityUrl()+"/"+id+".json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    create(entreprise : Entreprise): Promise<Entreprise> {
        return this.http
            .post(this.getEntityUrl(), this.serialize(entreprise), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    update(entreprise: Entreprise): Promise<Entreprise>{
        const url = `${this.getEntityUrl()}/${entreprise.id}`;
        return this.http
            .put(url, this.serialize(entreprise), {headers: this.headers})
            .toPromise()
            .then(() => entreprise)
            .catch(this.handleError);
    }

    remove(id: number): Promise<void> {
        const url = `${this.getEntityUrl()}/${id}`;
        return this.http.delete(url, {headers: this.headers})
            .toPromise()
            .then(() => null)
            .catch(this.handleError);
    }

    protected serialize(obj : Object): String {
        var str = [], p;
        for(p in obj) {
            if (obj.hasOwnProperty(p)) {
                var k = p, v = obj[p];
                if(v != null && k != "id"){
                    if(v !== null && typeof v === "object"){
                        if(k == 'entrepriseCategory'){
                            var id;
                            for(id in v){
                                str.push(this.prefix + this.getEntityName() + "[" + k + "][" + id + "][category]=" + encodeURIComponent(v[id]));
                            }
                        } else {
                            str.push(this.serialize(v));
                        }
                    } else {
                        str.push(this.prefix + this.getEntityName() + "[" + k + "]=" + encodeURIComponent(v));
                    }
                }
            }
        }
        return str.join("&");
    }
}