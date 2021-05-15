package Controllers;

import Controllers.InterfaceEventController;
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

public class HomePe implements Initializable {

    @FXML
    private Button planning;

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }


    public void planification(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource(
                            "../gui/ConsulterImprimer.fxml"                   )
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(
                    new Scene(loader.load())
            );

            ConsulterImprimer  controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }
    }



    public void evenement(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource(
                            "../gui/InterfaceEvent.fxml"                   )
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(
                    new Scene(loader.load())
            );

            InterfaceEventController controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }
    }


    public void retour(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource(
                            "../gui/HomeAdmin.fxml"
                    )
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(
                    new Scene(loader.load())
            );

            HomeAdmin controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }
    }

}




