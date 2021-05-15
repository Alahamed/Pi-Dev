
package intService;

import Entity.Events;
import java.sql.SQLException;
import java.util.List;

/**
 *
 * @author ComputerT
 */
public interface IServiceEvent {
    public void AddEvent(Events p);
    public List<Events> AfficherEvent()throws SQLException;
    public void deleteEvent(String nome);

  
    public void updateEvent(Events p);
  
    
}
