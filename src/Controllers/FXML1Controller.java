/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controllers;

import helpers.Maconnexion;
import Entity.Planning;
import helpers.javaMail;
import javafx.beans.property.ReadOnlyObjectWrapper;
import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.geometry.Pos;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;
import org.controlsfx.control.Notifications;
import service.ServicePlanning;


import java.net.URL;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.time.LocalDate;
import java.util.List;
import java.util.ResourceBundle;

/**
 * FXML Controller class
 *
 * @author user
 */
public class FXML1Controller implements Initializable {


    @FXML
    private DatePicker date;
    @FXML
    private Button btnajouter;
    @FXML
    private Label alerte;

    @FXML
    private ComboBox<String> combo;
    @FXML
    private ComboBox<String> combonom;
    @FXML
    private ComboBox<String> comboprenom;
    @FXML
    private Button txfupdate;
    @FXML
    private TableView<Planning> LAffiche;
    @FXML
    private TableColumn<Planning, Integer> colid;
    @FXML
    private TableColumn<Planning, String> colevent;
    @FXML
    private TableColumn<Planning, String> colnom;
    @FXML
    private TableColumn<Planning, String> colprenom;
    @FXML
    private TableColumn<Planning, Planning> colAction;
    @FXML
    private TableColumn<Planning, LocalDate> coldate;


    @Override
    public void initialize(URL url, ResourceBundle rb) {
        try {

            Connection cnx;


            cnx = Maconnexion.getInstance().getConnection();

            Statement stm = cnx.createStatement();

            String query = "select nom_event from events ";
            ResultSet rst = stm.executeQuery(query);

            while (rst.next()) {
                combo.getItems().addAll(rst.getString("nom_event"));
            }

        } catch (SQLException ex) {
            System.err.println("Error" + ex);
        }

        try {

            Connection cnx;


            cnx = Maconnexion.getInstance().getConnection();

            Statement stm = cnx.createStatement();
            Planning p = new Planning();

            String query = "select nom from personne";
            ResultSet rst = stm.executeQuery(query);

            while (rst.next()) {

                combonom.getItems().addAll(rst.getString("nom"));
            }

        } catch (SQLException ex) {
            System.err.println("Error" + ex);
        }
        try {

            Connection cnx;


            cnx = Maconnexion.getInstance().getConnection();

            Statement stm = cnx.createStatement();
            Planning p = new Planning();

            String query = "select prenom  from personne ";
            ResultSet rst = stm.executeQuery(query);

            while (rst.next()) {
                comboprenom.getItems().addAll(rst.getString("prenom"));


            }

        } catch (SQLException ex) {
            System.err.println("Error" + ex);
        }


    }


    @FXML
    private void AjouterPlanning(ActionEvent event) {
        ServicePlanning sp = new ServicePlanning();
        Planning p = new Planning();



        if(combo.getSelectionModel().isEmpty()||combonom.getSelectionModel().isEmpty()||comboprenom.getSelectionModel().isEmpty()){
            alerte.setText("vous devez ajouter le champ vide");

            combo.requestFocus();
            combonom.requestFocus();
            comboprenom.requestFocus();
            System.out.println("rien");

        } else {


            p.setNom_event(combo.getValue());
            p.setNom(combonom.getValue());
            p.setPrenom(comboprenom.getValue());

            p.setDate_creation(date.getValue());
            sp.AddPlanning(p);

            Notifications n = Notifications.create()
                    .title("Succès")
                    .text("Planning ajoute avec succès")
                    .graphic(null)
                    .position(Pos.TOP_CENTER);
            // .hideAfter(Duration.ofSeconds(3));
            n.showInformation();


            combo.setValue(null);
            combonom.setValue(null);
            comboprenom.setValue(null);

            date.setValue(null);

        }
    }

    @FXML
    private void AfficherPlanning(ActionEvent event) throws SQLException {

        display();
    }

    public void display() throws SQLException {
        ServicePlanning p = new ServicePlanning();
        List<Planning> list = p.AfficherPlanning();
        ObservableList<Planning> list1 = FXCollections.observableArrayList();

        list1.addAll(list);

        LAffiche.setItems(list1);
        colid.setCellValueFactory(new PropertyValueFactory<>("id_planning"));

        colevent.setCellValueFactory(new PropertyValueFactory<>("nom_event"));

        colnom.setCellValueFactory(new PropertyValueFactory<>("nom"));

       colprenom.setCellValueFactory(new PropertyValueFactory<>("prenom"));
        coldate.setCellValueFactory(new PropertyValueFactory<>("date_creation"));

        colAction.setCellValueFactory(column -> new ReadOnlyObjectWrapper<>(column.getValue()));
        colAction.setCellFactory(column -> {
            return new TableCell<Planning, Planning>() {
                private final Button deleteButton = new Button("supprimer");

                @Override
                protected void updateItem(Planning planning, boolean empty) {
                    super.updateItem(planning, empty);
                    if (planning == null) {
                        setGraphic(null);
                        return;
                    }
                    setGraphic(deleteButton);
                    ServicePlanning p = new ServicePlanning();
                    deleteButton.setOnAction(new EventHandler<ActionEvent>() {
                        @Override
                        public void handle(ActionEvent event) {
                            p.deletePlanning(planning.getId_planning());


                        }
                    });

                    LAffiche.getSelectionModel().selectedItemProperty().addListener(new ChangeListener<Planning>() {
                        @Override
                        public void changed(ObservableValue<? extends Planning> observable, Planning oldValue, Planning newValue) {
                            if (LAffiche.getSelectionModel().getSelectedItem() != null) {

                               combo.setValue(LAffiche.getSelectionModel().getSelectedItem().getNom_event());
                               combonom.setValue(LAffiche.getSelectionModel().getSelectedItem().getNom());
                               comboprenom.setValue(LAffiche.getSelectionModel().getSelectedItem().getPrenom());
                                date.setValue(LAffiche.getSelectionModel().getSelectedItem().getDate_creation());

                            }
                        }

                    });

                }
            };
        });
    }


                @FXML
    private void UpdatePlanning(ActionEvent event) {

        ServicePlanning sp = new ServicePlanning();
        Planning p = new Planning();

        p.setNom_event(combo.getValue());
        p.setNom(combonom.getValue());
        p.setPrenom(comboprenom.getValue());
        p.setDate_creation(date.getValue());
        sp.updatePlanning(p);
        combo.setValue(null);
        combonom.setValue(null);
        comboprenom.setValue(null);
        date.setValue(null);

    }

    @FXML
    private void EnvoyerPlanning(ActionEvent event) {
        try {

            ServicePlanning sp = new ServicePlanning();
            Planning p = new Planning();
           p.setNom_event(combo.getValue());
            p.setNom(combonom.getValue());
           p.setPrenom(comboprenom.getValue());

            String Object = "Planning  ";
            String Corps = "Bonjour nom_event='" + p.getNom_event() +
                  "', nom='" + p.getNom() + "', prenom='" + p.getPrenom() + "'  notre evénement commence le  et se termine le ";
            javaMail.sendMail("inovvat@gmail.com", Object, Corps);
        } catch (Exception e) {
            e.printStackTrace();
        }

    }
}

