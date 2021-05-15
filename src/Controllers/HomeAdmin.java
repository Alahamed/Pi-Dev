package Controllers;


import Controllers.HomePe;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;

public class HomeAdmin implements Initializable {

    @FXML
    private Button Home;
    @FXML
    private Button GestionUser;


    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }
    @FXML
    void GUaction(ActionEvent event) throws Exception {

        Parent root  = FXMLLoader.load(getClass().getResource("../gui/GestionUser.fxml"));

        Stage window =(Stage) GestionUser.getScene().getWindow();
        window.setScene(new Scene(root, 750, 500));
    }


    @FXML
    public void Home(ActionEvent event) throws Exception {
        Parent root  = FXMLLoader.load(getClass().getResource("../gui/Home.fxml"));

        Stage window =(Stage) Home.getScene().getWindow();
        window.setScene(new Scene(root, 750, 500));
    }

@FXML
    public void contacter(ActionEvent event) {

       /* try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource(
                            "../message/MessageAdmin.fxml"
                    )
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(new Scene(loader.load()));

            HelpDesk.message.ControlleurAdminMessage controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }*/

    }
    public void pe(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource(
                            "../gui/HomePe.fxml"                   )
            );

            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow(); //this accesses the window.
            stage.setScene(
                    new Scene(loader.load())
            );

            Controllers.HomePe controller = loader.getController();

            stage.show();
        } catch (IOException ex) {
        }
    }

}
