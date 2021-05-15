package Controllers;

import java.net.URL;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDate;
import java.util.LinkedList;
import java.util.List;
import java.util.ResourceBundle;
import java.util.prefs.Preferences;

import Entity.Planning;


import javafx.fxml.Initializable;

import javafx.fxml.FXML;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import service.ServicePlanning;


public class InterfaceUserController implements Initializable {

    @FXML
    private TableView<Planning> LAffiche;

    @FXML
    private TableColumn<Planning, String> colevent;
    @FXML
    private TableColumn<Planning, String> colnom;
    @FXML
    private TableColumn<Planning, String> colprenom;
    @FXML
    private TableColumn<Planning, LocalDate> coldeb;
    @FXML
    private TableColumn<Planning, LocalDate> colfin;


    @FXML
    private TextField filterField;



    @Override
    public void initialize(URL url, ResourceBundle rb) {

        Preferences userPreferences = Preferences.userRoot();
        String role = userPreferences.get("role", null);
        String nom = userPreferences.get("nom", null);
        String prenom = userPreferences.get("prenom", null);
        // nomPrenomLabel.setText(prenom +" - "+nom+" : "+role);
        this.refreshTableNormal();

        this.filterField.textProperty().addListener((obs, ov, nv) -> {
            System.out.println(nv.toString());
            if (nv.length() != 0) {
                refreshTableFiltred(nv);
            } else {
               // this.refreshTableNormal();
            }
        });

    }

    public List<Planning> fetchAll() {
        try {
            ServicePlanning sp = new ServicePlanning();
            ResultSet data = sp.consulterPlanning();
            List l = new LinkedList();
            while (data.next()) {
                Planning e = new Planning();
                // e.setId_event(data.getInt("id_event"));
                e.setNom_event(data.getString("nom_event"));
                e.setNom(data.getString("nom"));
                e.setPrenom(data.getString("prenom"));


                l.add(e);
            }
            return l;
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
            return null;
        }
    }

    public List<Planning> fetchAlternate(String keyword) {
        try {
            ServicePlanning sp = new ServicePlanning();
            ResultSet data = sp.AfficherPlannig1(keyword);
            List l = new LinkedList();

            while (data.next()) {
                Planning e = new Planning();
                // e.setId_event(data.getInt("id_event"));
                e.setNom_event(data.getString("nom_event"));
                e.setNom(data.getString("nom"));
                e.setPrenom(data.getString("prenom"));



                l.add(e);

            }
            return l;
        } catch (SQLException e) {
            System.out.println(e.getMessage());
            return null;
        }
    }

    public void refreshTableFiltred(String keyword) {
        try {
            colnom.setCellValueFactory(new PropertyValueFactory<>("nom"));
            colprenom.setCellValueFactory(new PropertyValueFactory<>("prenom"));
            colevent.setCellValueFactory(new PropertyValueFactory<>("nom_event"));

            LAffiche.getItems().setAll(fetchAlternate(keyword));
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

    public void refreshTableNormal() {
        try {
            colnom.setCellValueFactory(new PropertyValueFactory<>("nom"));
            colprenom.setCellValueFactory(new PropertyValueFactory<>("prenom"));
            colevent.setCellValueFactory(new PropertyValueFactory<>("nom_event"));

            //LAffiche.getItems().setAll(fetchAll());
        } catch (Exception e) {
            System.out.println(e.getMessage());

       }

    }



}

