/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package service;

import Entity.Planning;
import intService.IServicePlanning;
import helpers.Maconnexion;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author user
 */
public class ServicePlanning implements IServicePlanning {
    Connection cnx;

    public ServicePlanning() {
        cnx = Maconnexion.getInstance().getConnection();
    }

    @Override
    public void AddPlanning(Planning p) {

        try {
            Statement stm = cnx.createStatement();

            String req = "INSERT INTO planning( id_planning, nom_event,nom,prenom,date_creation) VALUES ('" + p.getId_planning() + "','" + p.getNom_event() + "','" + p.getNom() + "','" + p.getPrenom() + "','" + p.getDate_creation() + "')";
            stm.executeUpdate(req);
        } catch (SQLException ex) {
            Logger.getLogger(ServicePlanning.class.getName()).log(Level.SEVERE, null, ex);
        }

    }


    @Override
    public List<Planning> AfficherPlanning() throws SQLException {


        Statement stm = cnx.createStatement();

        String query = "select * from planning ";
        ResultSet rst = stm.executeQuery(query);

        List<Planning> Planning = new ArrayList<>();
        while (rst.next()) {
            Planning p = new Planning();

            p.setId_planning(rst.getInt("id_planning"));

            p.setNom_event(rst.getString("nom_event"));
            p.setNom(rst.getString("nom"));
            p.setPrenom(rst.getString("prenom"));
            p.setDate_creation(rst.getDate("date_creation").toLocalDate());

            Planning.add(p);


        }

        return Planning;


    }

    @Override
    public void updatePlanning(Planning p) {

        try {
            Statement stm = cnx.createStatement();

            String query = "UPDATE planning SET `nom_event`='" + p.getNom_event() + "', `date_creation`='" + p.getDate_creation() + "', `nom`='" + p.getNom() + "', `prenom`='" + p.getPrenom() + "' where nom_event='" + p.getNom_event() + "' ";


            stm.executeUpdate(query);
        } catch (SQLException ex) {
            Logger.getLogger(ServicePlanning.class.getName()).log(Level.SEVERE, null, ex);
        }
    }


    @Override
    public void deletePlanning(int id) {
        try {
            Statement stm = cnx.createStatement();

            String query = "DELETE  FROM planning WHERE `id_planning`='" + id + "'";
            System.out.println(query);
            stm.execute(query);
        } catch (SQLException ex) {
            Logger.getLogger(ServicePlanning.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public ResultSet AfficherPlannig1(String keyword) {
        try {
            String query = "SELECT nom_event,nom,prenom FROM planning WHERE nom LIKE '%" + keyword + "%'";
            Statement statement = cnx.createStatement();
            ResultSet rs = statement.executeQuery(query);
            return rs;
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
            return null;
        }
    }

    public ResultSet consulterPlanning() {
        try {
            String query = "SELECT * FROM planning";
            Statement statement = cnx.createStatement();
            ResultSet rs = statement.executeQuery(query);
            return rs;
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
            return null;

        }

    }
}

   











       
    

 


