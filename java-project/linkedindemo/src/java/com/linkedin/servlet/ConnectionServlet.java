package com.linkedin.servlet;

import com.linkedin.dao.ConnectionDAO;
import com.linkedin.dao.UserDAO;
import com.linkedin.model.Connection;
import com.linkedin.model.User;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import java.io.IOException;
import java.util.List;

@WebServlet("/connections")
public class ConnectionServlet extends HttpServlet {
    private ConnectionDAO connectionDAO;
    private UserDAO userDAO;
    
    @Override
    public void init() {
        connectionDAO = new ConnectionDAO();
        userDAO = new UserDAO();
    }
    
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        HttpSession session = request.getSession();
        User user = (User) session.getAttribute("user");
        
        if (user == null) {
            response.sendRedirect("login");
            return;
        }
        
        String action = request.getParameter("action");
        
        if ("search".equals(action)) {
            String query = request.getParameter("query");
            if (query != null && !query.trim().isEmpty()) {
                List<User> searchResults = userDAO.searchUsers(query);
                request.setAttribute("searchResults", searchResults);
            }
        }
        
        List<Connection> myConnections = connectionDAO.getAcceptedConnections(user.getId());
        List<Connection> pendingRequests = connectionDAO.getPendingConnections(user.getId());
        
        request.setAttribute("myConnections", myConnections);
        request.setAttribute("pendingRequests", pendingRequests);
        request.getRequestDispatcher("connections.jsp").forward(request, response);
    }
    
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        HttpSession session = request.getSession();
        User user = (User) session.getAttribute("user");
        
        if (user == null) {
            response.sendRedirect("login");
            return;
        }
        
        String action = request.getParameter("action");
        
        switch (action) {
            case "send":
                int addresseeId = Integer.parseInt(request.getParameter("addresseeId"));
                connectionDAO.sendConnectionRequest(user.getId(), addresseeId);
                break;
                
            case "accept":
                int connectionId = Integer.parseInt(request.getParameter("connectionId"));
                connectionDAO.updateConnectionStatus(connectionId, "accepted");
                break;
                
            case "reject":
                int rejectConnectionId = Integer.parseInt(request.getParameter("connectionId"));
                connectionDAO.updateConnectionStatus(rejectConnectionId, "rejected");
                break;
        }
        
        response.sendRedirect("connections");
    }
}