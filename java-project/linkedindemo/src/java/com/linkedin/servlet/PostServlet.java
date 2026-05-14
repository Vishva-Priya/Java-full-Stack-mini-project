package com.linkedin.servlet;

import com.linkedin.dao.PostDAO;
import com.linkedin.model.Post;
import com.linkedin.model.User;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import java.io.IOException;

@WebServlet("/post")
public class PostServlet extends HttpServlet {
    private PostDAO postDAO;
    
    @Override
    public void init() {
        postDAO = new PostDAO();
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
        
        String content = request.getParameter("content");
        
        if (content != null && !content.trim().isEmpty()) {
            Post post = new Post(user.getId(), content);
            
            if (postDAO.createPost(post)) {
                response.sendRedirect("home");
            } else {
                request.setAttribute("error", "Failed to create post.");
                response.sendRedirect("home");
            }
        } else {
            response.sendRedirect("home");
        }
    }
}