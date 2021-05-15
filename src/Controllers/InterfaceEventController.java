package Controllers;
import Entity.Events;
import javafx.geometry.Pos;
import javafx.scene.control.*;
import org.controlsfx.control.Notifications;
import service.ServiceEvent;
import java.net.URL;
import java.sql.ResultSet;
import java.time.LocalDate;
import java.util.List;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.beans.property.ReadOnlyObjectWrapper;
import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.Initializable;
import javafx.scene.control.cell.PropertyValueFactory;
import java.sql.SQLException;
import java.util.LinkedList;
import java.util.prefs.Preferences;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;

public class InterfaceEventController implements Initializable {

    private TextField txfidf;
    @FXML
    private Button addBtn;
    @FXML
    private TableView<Events> LAffiche;

    private DatePicker date;
    @FXML
    private Button updateBtn;
    @FXML
    private Label alerte;
    private TextField tlib;

    private TableColumn<Events, Integer> colidf;
    private TableColumn<Events, LocalDate> coldate;
    private TableColumn<Events, String> collibelle;
    @FXML
    private TableColumn<Events, Events> colAction;
    private TableColumn<Events, Integer> colevent;
    private TextField txfevent;
    @FXML
    private TextField filterField;
    @FXML
    private TextField txfnomevent;
    @FXML
    private DatePicker datedeb;
    @FXML
    private DatePicker datefin;
    @FXML
    private TableColumn<Events, String> colnom;

    @FXML
    private TableColumn<Events, LocalDate> coldeb;
    @FXML
    private TableColumn<Events, LocalDate> colfin;

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
               this.refreshTableNormal();
            }
        });

    }

    public List<Events> fetchAll() {
        try {
            ServiceEvent sp = new ServiceEvent();
            ResultSet data = sp.consulterToutEvents();
            List l = new LinkedList();
            while (data.next()) {
                Events e = new Events();
               // e.setId_event(data.getInt("id_event"));
                e.setNom_event(data.getString("nom_event"));
                e.setDate_deb(data.getDate("date_deb").toLocalDate());
                e.setDate_fin(data.getDate("date_fin").toLocalDate());

                l.add(e);
            }
            return l;
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
            return null;
        }
    }

    public List<Events> fetchAlternate(String keyword) {
        try {
            ServiceEvent sp = new ServiceEvent();
            ResultSet data = sp.AfficherEvents(keyword);
            List l = new LinkedList();

            while (data.next()) {
                Events e = new Events();
               // e.setId_event(data.getInt("id_event"));
                e.setNom_event(data.getString("nom_event"));
                e.setDate_deb(data.getDate("date_deb").toLocalDate());
                e.setDate_fin(data.getDate("date_fin").toLocalDate());

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
            colnom.setCellValueFactory(new PropertyValueFactory<>("nom_event"));
            coldeb.setCellValueFactory(new PropertyValueFactory<>("date_deb"));
            colfin.setCellValueFactory(new PropertyValueFactory<>("date_fin"));
            LAffiche.getItems().setAll(fetchAlternate(keyword));
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

    public void refreshTableNormal() {
        try {
            colnom.setCellValueFactory(new PropertyValueFactory<>("nom_event"));
            coldeb.setCellValueFactory(new PropertyValueFactory<>("date_deb"));
            colfin.setCellValueFactory(new PropertyValueFactory<>("date_fin"));
            //LAffiche.getItems().setAll(fetchAll());
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

    @FXML
    private void AjouterEvent(ActionEvent event) throws SQLException {
        ServiceEvent sp = new ServiceEvent();
        Events p = new Events();
        if(txfnomevent.getText().isEmpty()||datedeb.getValue()==null||datefin.getValue()==null) {
            alerte.setText("vous devez ajouter le champ vide");

            txfnomevent .requestFocus();
            datedeb .requestFocus();
            datefin.requestFocus();
            System.out.println("rien");
        }else {
            p.setNom_event(txfnomevent.getText());
            p.setDate_deb(datedeb.getValue());
            p.setDate_fin(datefin.getValue());
            sp.AddEvent(p);
            Notifications n = Notifications.create()
                    .title("Succès")
                    .text("Evenement ajouté avec succé")
                    .graphic(null)
                    .position(Pos.TOP_CENTER);
            // .hideAfter(Duration.ofSeconds(3));
            n.showInformation();

        }
    }

    @FXML
    private void AfficherEvent(ActionEvent event) throws SQLException {

        display();
    }

    public void display() throws SQLException {
        ServiceEvent p = new ServiceEvent();
        List<Events> list = p.AfficherEvent();
        ObservableList<Events> list1 = FXCollections.observableArrayList();

        list1.addAll(list);

        LAffiche.setItems(list1);

        colnom.setCellValueFactory(new PropertyValueFactory<>("nom_event"));

        coldeb.setCellValueFactory(new PropertyValueFactory<>("date_deb"));

        colfin.setCellValueFactory(new PropertyValueFactory<>("date_fin"));

        colAction.setCellValueFactory(column -> new ReadOnlyObjectWrapper<>(column.getValue()));
        colAction.setCellFactory(column -> {
            return new TableCell<Events, Events>() {
                private final Button deleteButton = new Button("supprimer");

                @Override
                protected void updateItem(Events events, boolean empty) {
                    super.updateItem(events, empty);
                    if (events == null) {
                        setGraphic(null);
                        return;
                    }
                    setGraphic(deleteButton);
                    ServiceEvent p = new ServiceEvent();
                    deleteButton.setOnAction(new EventHandler<ActionEvent>() {
                        @Override
                        public void handle(ActionEvent event) {
                            p.deleteEvent(events.getNom_event());

                            try {
                                init();
                            } catch (SQLException ex) {
                                Logger.getLogger(InterfaceEventController.class.getName()).log(Level.SEVERE, null, ex);
                            }
                        }
                    });

                    LAffiche.getSelectionModel().selectedItemProperty().addListener(new ChangeListener<Events>() {
                        @Override
                        public void changed(ObservableValue<? extends Events> observable, Events oldValue, Events newValue) {
                            if (LAffiche.getSelectionModel().getSelectedItem() != null) {
                                txfnomevent.setText(String.valueOf(LAffiche.getSelectionModel().getSelectedItem().getNom_event()));

                                datedeb.setValue(LAffiche.getSelectionModel().getSelectedItem().getDate_deb());
                                datefin.setValue(LAffiche.getSelectionModel().getSelectedItem().getDate_fin());

                                updateBtn.setDisable(false);
                                addBtn.setDisable(true);
                            }
                        }

                    });

                }
            };
        });
    }

    @FXML
    private void btnUpdate(ActionEvent event) throws SQLException {
        ServiceEvent sp = new ServiceEvent();
        Events p = new Events();
        p.setNom_event(txfnomevent.getText());
        p.setDate_deb(datedeb.getValue());
        p.setDate_fin(datefin.getValue());
        sp.updateEvent(p);
        init();
    }

    @FXML
    private void btnInit(ActionEvent event) throws SQLException {

        init();

    }

    public void init() throws SQLException {
        txfnomevent.setText("");
        datedeb.setValue(null);
        datefin.setValue(null);
        updateBtn.setDisable(true);
        addBtn.setDisable(false);
        display();
    }

}



