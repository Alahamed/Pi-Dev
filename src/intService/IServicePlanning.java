/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package intService;

import Entity.Planning;
import java.sql.SQLException;
import java.util.List;

/**
 *
 * @author user
 */
public interface IServicePlanning {
     public void AddPlanning(Planning p);
    public List<Planning> AfficherPlanning()throws SQLException;
    public void deletePlanning(int id);

  
    public void updatePlanning(Planning p);
    
}
