/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Diffusion } from '../class/diffusion'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import { OAuthService } from "angular-oauth2-oidc";

@Injectable()
export class DiffusionService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'diffusion';
    }

    getDiffusions(): Promise<Diffusion[]>{
        return this.http.get(this.getEntityUrl()+"s", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    getDiffusion(id: number): Promise<Diffusion> {
        return this.http.get(this.getEntityUrl()+"/"+id+".json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    create(diffusion: Diffusion): Promise<Diffusion> {
        return this.http
            .post(this.getEntityUrl(), this.serialize(diffusion), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    update(diffusion: Diffusion): Promise<Diffusion>{
        const url = `${this.getEntityUrl()}/${diffusion.id}`;
        return this.http
            .put(url, this.serialize(diffusion), {headers: this.headers})
            .toPromise()
            .then(() => diffusion)
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
                        if(k == 'diffusionLocal'){
                            var id;
                            for(id in v){
                                str.push(this.prefix + this.getEntityName() + "[" + k + "][" + id + "][local]=" + encodeURIComponent(v[id]));
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