package Controllers;

import Controllers.FXML1Controller;
import Controllers.InterfaceImprimerController;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;

public class ConsulterImprimer implements Initializable {

    @FXML
    private Button planning;

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }


    public void gest(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource(
                            "../gui/FXML1.fxml")
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(
                    new Scene(loader.load())
            );

            FXML1Controller controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }
    }


    public void imp(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource("../gui/InterfaceImprimer.fxml")
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(
                    new Scene(loader.load())
            );

            InterfaceImprimerController controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }
    }


    public void annuler(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource("../gui/HomePe.fxml")
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(
                    new Scene(loader.load())
            );

            HomePe controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }
    }
}