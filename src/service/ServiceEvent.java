package service;

import Entity.Events;

import helpers.Maconnexion;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import intService.IServiceEvent;

/**
 *
 * @author ComputerT
 */
public class ServiceEvent implements IServiceEvent {
    Connection cnx;

    public ServiceEvent() {
        cnx = Maconnexion.getInstance().getConnection();
    }

    @Override
    public void AddEvent(Events p) {
        try {
            Statement stm = cnx.createStatement();
            String req = "INSERT INTO events(  nom_event,date_deb,date_fin) VALUES ('" + p.getNom_event() + "','" + p.getDate_deb()+ "','" + p.getDate_fin() + "')";
            stm.executeUpdate(req);
        } catch (SQLException ex) {
            Logger.getLogger(ServiceEvent.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public List<Events> AfficherEvent() throws SQLException {
        Statement stm = cnx.createStatement();
        String query = "select * from events ";
        ResultSet rst = stm.executeQuery(query);
        List<Events> Event = new ArrayList<>();
        while (rst.next()) {
            Events p = new Events();
            p.setDate_fin(rst.getDate("date_fin").toLocalDate());
            p.setDate_deb(rst.getDate("date_deb").toLocalDate());
            p.setNom_event(rst.getString("nom_event"));
            Event.add(p);
        }
        return Event;

    }

    @Override
    public void deleteEvent(String nome ) {
        try {
            Statement stm = cnx.createStatement();
            String query = "DELETE FROM events WHERE `nom_event`='" + nome+ "'";

            System.out.println(query);
            stm.execute(query);
        } catch (SQLException ex) {
            Logger.getLogger(ServiceEvent.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @Override
    public void updateEvent(Events p) {
        try {
            Statement stm = cnx.createStatement();
            String query = "UPDATE events SET  `nom_event`='" + p.getNom_event() + "', `date_deb`='" + p.getDate_deb() + "', `date_fin`='" + p.getDate_fin() + "' where nom_event='" + p.getNom_event() + "' ";
            System.out.println(query);
            stm.executeUpdate(query);
        } catch (SQLException ex) {
            Logger.getLogger(ServiceEvent.class.getName()).log(Level.SEVERE, null, ex);
        }

    }
    public ResultSet AfficherEvents(String keyword) {
        try {
            String query = "SELECT * FROM events WHERE nom_event LIKE '%" + keyword + "%'";
            Statement statement = cnx.createStatement();
            ResultSet rs = statement.executeQuery(query);
            return rs;
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
            return null;
        }
    }

    public ResultSet consulterToutEvents() {
        try {
            String query = "SELECT * FROM events";
            Statement statement = cnx.createStatement();
            ResultSet rs = statement.executeQuery(query);
            return rs;
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
            return null;

        }
    }

}