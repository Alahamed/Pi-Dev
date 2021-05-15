package Controllers;

import Entity.Planning;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;


import javafx.print.*;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;


import javafx.scene.layout.Pane;
import service.ServicePlanning;

import java.net.URL;
import java.sql.SQLException;
import java.time.LocalDate;
import java.util.List;
import java.util.ResourceBundle;


/**
 * FXML Controller class
 *
 * @author user
 */
public class InterfaceImprimerController implements Initializable {


    @FXML
    private DatePicker date;
    @FXML
    private Button btnajouter;

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
    @FXML
    private Pane panel;


    @Override
    public void initialize(URL url, ResourceBundle rb) {


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

    }

    @FXML
    private void ImprimerPlanning(ActionEvent event) {
        print();
    }

    public void print() {

        Printer printer = Printer.getDefaultPrinter();

        PageLayout layout = printer.createPageLayout(Paper.A4, PageOrientation.PORTRAIT, Printer.MarginType.EQUAL);

        PrinterJob job = PrinterJob.createPrinterJob();

        if (job != null) {

            job.getJobSettings().setJobName("TestPrint");


            job.printPage(layout, this.panel);


            job.endJob();
        }


    }
}
