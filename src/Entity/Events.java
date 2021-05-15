package Entity;


import java.time.LocalDate;

public class Events {

    private int id_event;

    private String nom_event;
    private LocalDate date_deb;
    private LocalDate date_fin;

    public int getId_event() {
        return id_event;
    }

    public void setId_event(int id_event) {
        this.id_event = id_event;
    }

    public String getNom_event() {
        return nom_event;
    }

    public void setNom_event(String nom_event) {
        this.nom_event = nom_event;
    }

    public LocalDate getDate_deb() {
        return date_deb;
    }

    public void setDate_deb(LocalDate date_deb) {
        this.date_deb = date_deb;
    }

    public LocalDate getDate_fin() {
        return date_fin;
    }

    public void setDate_fin(LocalDate date_fin) {
        this.date_fin = date_fin;
    }

    public Events() {
    }

    public Events(int id_event, String nom_event, LocalDate date_deb, LocalDate date_fin) {
        this.id_event = id_event;
        this.nom_event = nom_event;
        this.date_deb = date_deb;
        this.date_fin = date_fin;
    }

    @Override
    public String toString() {
        return "Events{" + "id_event=" + id_event + ", nom_event=" + nom_event + ", date_deb=" + date_deb + ", date_fin=" + date_fin + '}';
    }





}














