package com.linkedin.servlet;

import com.linkedin.dao.UserDAO;
import com.linkedin.dao.PostDAO;
import com.linkedin.model.User;
import com.linkedin.model.Post;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import java.io.IOException;
import java.util.List;

@WebServlet("/profile")
public class ProfileServlet extends HttpServlet {
    private UserDAO userDAO;
    private PostDAO postDAO;
    
    @Override
    public void init() {
        userDAO = new UserDAO();
        postDAO = new PostDAO();
    }
    
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) 
            throws ServletException, IOException {
        HttpSession session = request.getSession();
        User currentUser = (User) session.getAttribute("user");
        
        if (currentUser == null) {
            response.sendRedirect("login");
            return;
        }
        
        String userIdParam = request.getParameter("userId");
        User profileUser;
        
        if (userIdParam != null) {
            int userId = Integer.parseInt(userIdParam);
            profileUser = userDAO.getUserById(userId);
        } else {
            profileUser = currentUser;
        }
        
        if (profileUser != null) {
            List<Post> userPosts = postDAO.getPostsByUserId(profileUser.getId());
            request.setAttribute("profileUser", profileUser);
            request.setAttribute("userPosts", userPosts);
            request.setAttribute("isOwnProfile", profileUser.getId() == currentUser.getId());
        }
        
        request.getRequestDispatcher("profile.jsp").forward(request, response);
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
        
        String firstName = request.getParameter("firstName");
        String lastName = request.getParameter("lastName");
        String headline = request.getParameter("headline");
        String summary = request.getParameter("summary");
        String location = request.getParameter("location");
        
        user.setFirstName(firstName);
        user.setLastName(lastName);
        user.setHeadline(headline);
        user.setSummary(summary);
        user.setLocation(location);
        
        if (userDAO.updateProfile(user)) {
            session.setAttribute("user", user);
            request.setAttribute("message", "Profile updated successfully!");
        } else {
            request.setAttribute("error", "Failed to update profile.");
        }
        
        request.getRequestDispatcher("profile.jsp").forward(request, response);
    }
}