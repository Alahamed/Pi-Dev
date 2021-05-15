/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entity;

import java.time.LocalDate;

public class Planning {

    private int id_planning;
    private String nom_event ;
    private String nom;
    private String prenom;
    private LocalDate date_creation;

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }


    public String getNom_event() {
        return nom_event;
    }

    public void setNom_event(String nom_event) {
        this.nom_event = nom_event;
    }



    public int getId_planning() {
        return id_planning;
    }

    public void setId_planning(int id_planning) {
        this.id_planning = id_planning;
    }

    public LocalDate getDate_creation() {
        return date_creation;
    }

    public void setDate_creation(LocalDate date_creation) {
        this.date_creation = date_creation;
    }

    public Planning() {
    }

    public Planning(String nom_event, int id_planning, LocalDate date_creation, String nom, String prenom) {
        this.nom_event = nom_event;
        this.id_planning = id_planning;
        this.date_creation = date_creation;
        this.nom = nom;
        this.prenom = prenom;
    }

    @Override
    public String toString() {
        return "Planning{" + "nom_event=" + nom_event + ", id_planning=" + id_planning + ", date_creation=" + date_creation + ", nom=" + nom + ", prenom=" + prenom + '}';
    }





}
