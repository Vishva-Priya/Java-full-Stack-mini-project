package com.linkedin.servlet;

import com.linkedin.dao.PostDAO;
import com.linkedin.dao.ConnectionDAO;
import com.linkedin.model.Post;
import com.linkedin.model.User;
import com.linkedin.model.Connection;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import java.io.IOException;
import java.util.List;

@WebServlet("/home")
public class HomeServlet extends HttpServlet {
    private PostDAO postDAO;
    private ConnectionDAO connectionDAO;
    
    @Override
    public void init() {
        postDAO = new PostDAO();
        connectionDAO = new ConnectionDAO();
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
        
        List<Post> posts = postDAO.getAllPosts();
        List<Connection> pendingConnections = connectionDAO.getPendingConnections(user.getId());
        
        request.setAttribute("posts", posts);
        request.setAttribute("pendingConnections", pendingConnections);
        request.getRequestDispatcher("home.jsp").forward(request, response);
    }
}
